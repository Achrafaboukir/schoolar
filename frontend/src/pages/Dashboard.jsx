import React from 'react';
import { UserGroupIcon, AcademicCapIcon, BookOpenIcon, ChatBubbleLeftRightIcon } from '@heroicons/react/24/outline';
import { Line } from 'react-chartjs-2';
import {
  Chart as ChartJS,
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend,
} from 'chart.js';

ChartJS.register(
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend
);

const stats = [
  { name: 'Students', value: '932', icon: UserGroupIcon, color: 'bg-blue-500' },
  { name: 'Teachers', value: '754', icon: AcademicCapIcon, color: 'bg-purple-500' },
  { name: 'Courses', value: '40', icon: BookOpenIcon, color: 'bg-green-500' },
  { name: 'Feedback', value: '32', icon: ChatBubbleLeftRightIcon, color: 'bg-yellow-500' },
];

const chartData = {
  labels: ['January', 'February', 'March', 'April', 'May', 'June'],
  datasets: [
    {
      label: 'Student Enrollment',
      data: [65, 78, 90, 85, 95, 100],
      borderColor: 'rgb(59, 130, 246)',
      backgroundColor: 'rgba(59, 130, 246, 0.5)',
    },
    {
      label: 'Feedback Received',
      data: [45, 55, 65, 60, 70, 75],
      borderColor: 'rgb(147, 51, 234)',
      backgroundColor: 'rgba(147, 51, 234, 0.5)',
    },
  ],
};

const chartOptions = {
  responsive: true,
  plugins: {
    legend: {
      position: 'top',
    },
    title: {
      display: true,
      text: 'Platform Activity',
    },
  },
};

export default function Dashboard() {
  return (
    <div>
      <h1 className="text-2xl font-semibold text-gray-900">Dashboard</h1>
      
      <div className="mt-8 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        {stats.map((item) => (
          <div
            key={item.name}
            className="relative overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:px-6 sm:py-6"
          >
            <dt>
              <div className={`absolute rounded-md ${item.color} p-3`}>
                <item.icon className="h-6 w-6 text-white" aria-hidden="true" />
              </div>
              <p className="ml-16 truncate text-sm font-medium text-gray-500">
                {item.name}
              </p>
            </dt>
            <dd className="ml-16 flex items-baseline">
              <p className="text-2xl font-semibold text-gray-900">{item.value}</p>
            </dd>
          </div>
        ))}
      </div>

      <div className="mt-8">
        <div className="rounded-lg bg-white p-6 shadow">
          <Line options={chartOptions} data={chartData} />
        </div>
      </div>

      <div className="mt-8 grid grid-cols-1 gap-5 sm:grid-cols-2">
        <div className="rounded-lg bg-white p-6 shadow">
          <h2 className="text-lg font-medium text-gray-900">Recent Activity</h2>
          <ul className="mt-4 space-y-4">
            <li className="flex items-center space-x-3">
              <div className="flex-shrink-0">
                <UserGroupIcon className="h-5 w-5 text-gray-400" />
              </div>
              <div className="min-w-0 flex-1">
                <p className="text-sm text-gray-800">New student registration</p>
                <p className="text-xs text-gray-500">2 hours ago</p>
              </div>
            </li>
            <li className="flex items-center space-x-3">
              <div className="flex-shrink-0">
                <ChatBubbleLeftRightIcon className="h-5 w-5 text-gray-400" />
              </div>
              <div className="min-w-0 flex-1">
                <p className="text-sm text-gray-800">New feedback submitted</p>
                <p className="text-xs text-gray-500">4 hours ago</p>
              </div>
            </li>
          </ul>
        </div>

        <div className="rounded-lg bg-white p-6 shadow">
          <h2 className="text-lg font-medium text-gray-900">Top Courses</h2>
          <ul className="mt-4 space-y-4">
            <li className="flex items-center justify-between">
              <div className="flex items-center space-x-3">
                <div className="flex-shrink-0">
                  <BookOpenIcon className="h-5 w-5 text-gray-400" />
                </div>
                <div className="min-w-0 flex-1">
                  <p className="text-sm text-gray-800">Web Development</p>
                  <p className="text-xs text-gray-500">45 students</p>
                </div>
              </div>
              <div className="text-sm text-green-600">4.8/5</div>
            </li>
            <li className="flex items-center justify-between">
              <div className="flex items-center space-x-3">
                <div className="flex-shrink-0">
                  <BookOpenIcon className="h-5 w-5 text-gray-400" />
                </div>
                <div className="min-w-0 flex-1">
                  <p className="text-sm text-gray-800">Data Science</p>
                  <p className="text-xs text-gray-500">38 students</p>
                </div>
              </div>
              <div className="text-sm text-green-600">4.7/5</div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  );
} 